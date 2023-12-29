export interface HasOrExcept {
    id: string | number;
    name: string;
}

interface VideoDataIn {
    thumbnail: string;
    url: string;
}

export interface VideoData {
    description: string;
    id: number;
    tags_ids: number[];
    title: string;
    videoId: string;
    has_more: HasOrExcept[];
    tags: HasOrExcept[];
    video_data: VideoDataIn;
}

export interface VideoLinks {
    first: string | null;
    last: string | null;
    next: string | null;
    prev: string | null;
}

export interface Link {
    url: string | null;
    label: string;
    activa: boolean;
}

export interface VideoMeta {
    current_page: number;
    from: number;
    links: Link[];
    last_page: number;
    path: string;
    per_page: number;
    to: number;
    total: number;
}

export interface Video {
    data: VideoData[];
    links: VideoLinks;
    meta: VideoMeta;
}
