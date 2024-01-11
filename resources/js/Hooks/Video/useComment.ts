import { ref } from "vue";
import { Comment as CommentType } from "@/types/chat";
import VideoService from "@/Services/Video/VideoService";

type typeComment = CommentType[];
type typeChats = CommentType[];

interface AllComments {
    comments: typeComment;
    chats: typeChats;
}

const serviceVideo = new VideoService();
const useComment = () => {
    const dataInComment = ref<CommentType[]>([]);
    const isLoading = ref(true);

    const handleComment = async (id: number) => {
        if (id) {
            try {
                const path = route("videos.comments.index", {
                    video: id,
                });
                isLoading.value = true;
                await serviceVideo.fetchGetComment(path);
                const dataIn = serviceVideo.getData();
                const isArray = Array.isArray(dataIn.comments);
                const commentsInChatOrder = dataIn.chats.sort(
                    (a: CommentType, b: CommentType) => {
                        return (
                            new Date(b.created_at).getTime() -
                            new Date(a.created_at).getTime()
                        );
                    }
                );
                const dataWithComments: typeComment = isArray
                    ? dataIn.comments
                    : Object.values(dataIn.comments);
                console.log(dataWithComments, "pepe");
                console.log(commentsInChatOrder, "pepex2");
                dataInComment.value = [
                    ...commentsInChatOrder,
                    ...dataWithComments,
                ];
                isLoading.value = false;
            } catch (error) {
                console.log(error);
                isLoading.value = false;
            }
        }
    };

    return {
        isLoading,
        dataInComment,
        handleComment,
    };
};

export default useComment;
