export function edit() { return { url: '/settings/password', method: 'get' as const }; }
export function update() { return { url: '/settings/password', method: 'put' as const }; }
export default { edit, update };
