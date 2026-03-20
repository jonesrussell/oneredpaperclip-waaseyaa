export function index() { return { url: '/api/challenges', method: 'get' as const }; }
export function show(challenge: number | { id: number }) { const id = typeof challenge === 'number' ? challenge : challenge.id; return { url: `/api/challenges/${id}`, method: 'get' as const }; }
export function store() { return { url: '/api/challenges', method: 'post' as const }; }
export function mine() { return { url: '/api/challenges/mine', method: 'get' as const }; }
export default { index, show, store, mine };
