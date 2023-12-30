export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    nickname: string;
    img: string;
    super: boolean;
    img_path: string;
    admin: boolean;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        data: User;
    };
};
