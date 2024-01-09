import { ref, Ref } from "vue";
import axios from "axios";
import { Comment as CommentType } from "../../types/chat";

type typeComment = CommentType[];
type typeChats = CommentType[];

interface AllComments {
    comments: typeComment;
    chats: typeChats;
}
class VideoService {
    private success: Ref<string>;
    private data: Ref;

    constructor() {
        this.success = ref() as Ref<string>;
        this.data = ref([]) as unknown as Ref<AllComments>;
    }

    getMsgSuccess(): string {
        return this.success.value;
    }

    getData() {
        return this.data.value;
    }

    async fetchGetComment(path: string) {
        try {
            const { data } = await axios.get(path);
            // Only comments
            this.data.value = await data;
        } catch (error) {
            console.log(error, "error in chat service in create");
            throw `${error} error in chat service in create`;
        }
    }

    async fetchCreatedCommentInVideo(path: string, dataIn: string) {
        try {
            const { data } = await axios.post(path, dataIn);
            this.success.value = "Se registro correctamente la acción";
            this.data.value = await data.comment;
        } catch (error) {
            console.log(error, "error in chat service in create");
            throw `${error} error in chat service in create`;
        }
    }

    async fetchDeleteCommentInVideo(path: any) {
        try {
            await axios.delete(path);
            this.success.value = "Se elimino correctamente la acción";
        } catch (error) {
            console.log(error, "error in chat service in deleted");
            throw `${error} error in chat service in deleted`;
        }
    }

    async fetchUpdatedCommentInVideo(path: any, dataIn: { content: string }) {
        try {
            const { data } = await axios.put(path, dataIn);
            this.data.value = await data.data;
            this.success.value = "Se actualizo correctamente la accion";
        } catch (error) {
            console.log(error, "error in chat service in updated");
            throw `${error} error in chat service in updated`;
        }
    }
}

export default VideoService;
