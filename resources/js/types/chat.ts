import { User } from "./index.d";

interface CreatedBy {
    id: number;
    name: string;
    img: null | string;
    is_admin: boolean;
    roles: null;
}

export interface ChatContent {
    id: number;
    content: string;
    created_at: string;
    updated_at: string;
    created_by: CreatedBy;
    user: User;
}

export interface Comment {
    id: string;
    img: string;
    name: string;
    created_at: string;
    content: string;
}

export interface ChatAdminData {
    chats_count: number;
    created_at: string;
    email: string;
    id: number;
    img: string;
    img_url: string;
    is_admin: boolean;
    name: string;
    nickname: string;
    updated_at: string;
}

export interface ChatAdmin {
    current_page: number;
    last_page: number;
    data: ChatAdminData[];
}
