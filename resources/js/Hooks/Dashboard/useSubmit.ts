import { ref, Ref } from "vue";
import ChatService from "@/Services/Dashboard/ChatService";
import { ChatContent } from "@/types/chat";
import { toast } from "vue3-toastify";

const useSubmit = () => {
    const serviceChat = new ChatService();

    const isLoading = ref(false);
    const data = ref();

    const handleSubmit = async (url: string, dataIn: any) => {
        try {
            isLoading.value = true;
            await serviceChat.fetchCreateMsgInChat(url, dataIn);
            data.value = serviceChat.getData();
            toast(serviceChat.getMsgSuccess(), {
                autoClose: 1000,
                position: "top-right",
                type: "success",
            });
            isLoading.value = false;
        } catch (error) {
            toast(error as string, {
                autoClose: 1000,
                position: "top-right",
                type: "error",
            });
            isLoading.value = false;
        }
    };

    return {
        isLoading,
        data,
        handleSubmit,
    };
};

export default useSubmit;
