import { ref, Ref } from "vue";
import axios from "axios";
import { Comment } from "../../types/chat";

class VideoService {
    private success: Ref<string>;
    private data: Ref<Comment[]>;

    constructor() {
        this.success = ref() as Ref<string>;
        this.data = ref([]) as Ref<Comment[]>;
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
            this.data.value = await data.comments;
        } catch (error) {
            console.log(error, "error in chat service in create");
            throw `${error} error in chat service in create`;
        }
    }
}

export default VideoService;
