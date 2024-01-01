<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\ChatResource;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(): ChatCollection
    {
        $response = Chat::query()->whereUserId(\request("user"))->get();

        return new ChatCollection($response);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function indexInertia()
    {
        $response = User::query()
            ->whereRelation("chats", "user_id", "!=", null)
            ->withCount("chats")
            ->paginate(10);

        return inertia('Admin/Chat', [
            'users' => $response,
        ]);
    }

    public function edit($id)
    {
        $chats = Chat::query()
            ->where('user_id', $id)
            ->get();

        $chat = new ChatCollection($chats);

        return inertia('Admin/ChatEdit', [
            'user' => User::query()->find($id),
            'dataChat' => $chat
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreChatRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(StoreChatRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {

            $response = Chat::create(\request()->only("user_id", "content"));

            DB::commit();

            return (new ChatResource($response))->response()->setStatusCode(Response::HTTP_CREATED);

        } catch (\Throwable $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            \Log::error($error);
            DB::rollback();

            throw new \Exception($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateChatRequest $request
     * @param $id
     * @return JsonResponse|object
     * @throws \Exception
     */
    public function update(UpdateChatRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            \request()->merge(["user_id" => \auth()->id()]);
            $response = Chat::updateOrCreate([
                "id" => $id
            ], \request()->only("content"));

            DB::commit();

            return (new ChatResource($response))->response()->setStatusCode(Response::HTTP_CREATED);

        } catch (\Throwable $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            \Log::error($error);
            DB::rollback();

            throw new \Exception($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse|object
     */
    public function destroy($id): ?JsonResponse
    {
        return (new ChatResource(Chat::query()->find($id)->delete()))
            ->response()
            ->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
