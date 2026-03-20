export function edit() { return { url: '/settings/notifications', method: 'get' as const }; }
export function update() { return { url: '/settings/notifications', method: 'patch' as const }; }
export default { edit, update };
