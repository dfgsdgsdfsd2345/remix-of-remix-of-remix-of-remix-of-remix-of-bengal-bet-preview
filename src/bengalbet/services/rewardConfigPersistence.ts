export async function verifyRewardConfig<T>(
  expected: T,
  read: () => Promise<{ success: boolean; config: T }>,
): Promise<T> {
  const result = await read();
  const equal = (a: unknown, b: unknown): boolean => {
    if (Array.isArray(a)) return Array.isArray(b) && a.length === b.length && a.every((v, i) => equal(v, b[i]));
    if (a !== null && typeof a === 'object') {
      return b !== null && typeof b === 'object' && Object.entries(a).every(([k, v]) => equal(v, (b as Record<string, unknown>)[k]));
    }
    return a === b;
  };
  if (!result.success || !equal(expected, result.config)) throw new Error('সার্ভারে সংরক্ষিত নিয়ম যাচাই হয়নি। আবার লোড করুন।');
  return result.config;
}