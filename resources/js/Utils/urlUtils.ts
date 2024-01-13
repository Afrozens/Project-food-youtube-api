export function startsWithVideosHas(url: string) {
    return url.startsWith("/videos?has");
}

export function startsWithAdmin(url: string) {
    if (/^\/admin/.test(url) || /^\/chats/.test(url)) return true;
    return false;
}

export function startWithGuest(url: string) {
    switch (url) {
        case "/login":
            return true;
        case "/register":
            return true;
        case "/forgot-password":
            return true;
        default:
            return false;
    }
}
