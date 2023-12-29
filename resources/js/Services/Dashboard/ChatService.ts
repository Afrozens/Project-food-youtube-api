import axios from "axios";
import { Ref, ref } from "vue";

interface Content {
    content: string;
}

interface DataForChat extends Content {
    user_id: string | number;
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

    async fetchDeleteMsgInChat(path: any) {
        try {
            await axios.delete(path);
            this.success.value = "Se elimino correctamente la acción";
        } catch (error) {
            console.log(error, "error in chat service in deleted");
            throw `${error} error in chat service in deleted`;
        }
    }

    async fetchUpdatedMsgInChat(path: any, dataIn: Content) {
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

export default ChatService;
