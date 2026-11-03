import { describe, expect, it, vi } from 'vitest';
import { readWalletBalance } from '../bengalbet/services/walletRefresh';

describe('Server-owned wallet refresh', () => {
  it('returns exactly the server balance without adding money', async () => {
    const read = vi.fn().mockResolvedValue({ success: true, balance: 1470 });
    expect(await readWalletBalance(read)).toBe(1470);
    expect(read).toHaveBeenCalledTimes(1);
  });
  it('rejects failed or invalid balances', async () => {
    for (const result of [{ success: false, balance: 1470 }, { success: true, balance: NaN }, { success: true, balance: -1 }]) {
      await expect(readWalletBalance(async () => result)).rejects.toThrow();
    }
  });
});