import { ref, Ref } from "vue";
import { toast } from "vue3-toastify";
import ChatService from "@/Services/Dashboard/ChatService";
import VideoService from "@/Services/Video/VideoService";

type typeService = "chat" | "video";

const useSubmit = () => {
    const serviceChat = new ChatService();
    const serviceVideo = new VideoService();

    const isLoading = ref(false);
    const data = ref();

    const handleSubmit = async (
        url: string,
        dataIn: any,
        type: typeService
    ) => {
        try {
            let msgSuccess = "";
            isLoading.value = true;
            if (type === "chat") {
                await serviceChat.fetchCreateMsgInChat(url, dataIn);
                data.value = serviceChat.getData();
                msgSuccess = serviceChat.getMsgSuccess();
            } else {
                await serviceVideo.fetchCreatedCommentInVideo(url, dataIn);
                data.value = serviceVideo.getData();
                msgSuccess = serviceVideo.getMsgSuccess();
            }
            toast(msgSuccess, {
                autoClose: 1000,
                position: "top-right",
                type: "success",
            });
            isLoading.value = false;
            msgSuccess = "";
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
