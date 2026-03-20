export function edit() { return { url: '/settings/profile', method: 'get' as const }; }
export function update() { return { url: '/settings/profile', method: 'patch' as const }; }
export function destroy() { return { url: '/settings/profile', method: 'delete' as const }; }
export default { edit, update, destroy };
