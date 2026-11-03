/** Refreshes only server-owned balance; failed/invalid reads never fabricate cash. */
export async function readWalletBalance(read: () => Promise<{ success: boolean; balance: number }>): Promise<number> {
  const result = await read();
  if (!result.success || !Number.isFinite(result.balance) || result.balance < 0) {
    throw new Error('Wallet balance unavailable');
  }
  return result.balance;
}