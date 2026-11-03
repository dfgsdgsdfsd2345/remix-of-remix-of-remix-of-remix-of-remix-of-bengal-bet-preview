export function rebateTransactions(rows: unknown): Record<string, any>[] {
  if (!Array.isArray(rows)) return [];
  return rows.filter(row => row && row.type === 'bonus' && row.status === 'success' && Number(row.amount) > 0 && /^রিয়েল টাইম রিবেট(?:\s|$)/u.test(String(row.description ?? '')));
}