import { describe, expect, it } from 'vitest';
import { verifyRewardConfig } from '../bengalbet/services/rewardConfigPersistence';
describe('reward configuration readback', () => {
  const config = { enabled: true, days: [{ day: 1, bonus: 10 }] };
  it('confirms the server value, not only a successful write', async () => {
    await expect(verifyRewardConfig(config, async () => ({ success: true, config }))).resolves.toEqual(config);
  });
  it('rejects a stale reward amount', async () => {
    await expect(verifyRewardConfig(config, async () => ({ success: true, config: { ...config, days: [{ day: 1, bonus: 20 }] } }))).rejects.toThrow();
  });
  it('rejects a failed fresh read', async () => {
    await expect(verifyRewardConfig(config, async () => ({ success: false, config }))).rejects.toThrow();
  });
  it('confirms reset only when stored configuration is absent', async () => {
    await expect(verifyRewardConfig(null, async () => ({ success: true, config: null }))).resolves.toBeNull();
    await expect(verifyRewardConfig<unknown>(null, async () => ({ success: true, config }))).rejects.toThrow();
  });
});