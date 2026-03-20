export function index() { return { url: '/notifications', method: 'get' as const }; }
export function unreadCount() { return { url: '/notifications/unread-count', method: 'get' as const }; }
export function markAsRead(id: string) { return { url: `/notifications/${id}/read`, method: 'post' as const }; }
export function markAllAsRead() { return { url: '/notifications/mark-all-read', method: 'post' as const }; }
export default { index, unreadCount, markAsRead, markAllAsRead };
