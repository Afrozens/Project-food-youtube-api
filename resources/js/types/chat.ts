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
