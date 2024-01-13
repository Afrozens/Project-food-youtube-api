import axios from "axios";

class UploadAdapter {
    constructor(private loader: any) {
        this.loader = loader;
    }
    // Starts the upload process.
    async upload(loader: any) {
        const path = route("ckeditor.upload");
        const file = await this.loader.file;
        const formData = new FormData();
        formData.append("upload", file);
        const { data } = await axios.post(path, formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
            withCredentials: false,
        });

        const dataIn = {
            ...data,
            default: data.url,
            width: 800,
            height: 600,
        };
        console.log(dataIn, "pepe");
        return dataIn;
    }

    abort() {
        // Reject the promise returned from the upload() method.
    }
}
export const uploader = function (editor: any) {
    editor.plugins.get("FileRepository").createUploadAdapter = (
        loader: any
    ) => {
        return new UploadAdapter(loader);
    };
};
