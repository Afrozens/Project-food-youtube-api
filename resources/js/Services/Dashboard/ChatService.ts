import axios from "axios";
import { Ref, ref } from "vue";

interface DataForChat {
    user_id: string | number;
    content: string;
}

class ChatService {
    private success: Ref<string>;
    private data: Ref<any>;

    constructor() {
        this.success = ref() as Ref<string>;
        this.data = ref();
    }

    getMsgSuccess(): string {
        return this.success.value;
    }

    getData(): string {
        return this.data.value;
    }

    async fetchCreateMsgInChat(path: string, dataIn: DataForChat) {
        try {
            const { data } = await axios.post(path, dataIn);
            this.success.value = "Se registro correctamente la acción";
            this.data.value = await data.data;
        } catch (error) {
            console.log(error, "error in chat service in create");
            throw `${error} error in chat service in create`;
        }
    }
}

export default ChatService;
