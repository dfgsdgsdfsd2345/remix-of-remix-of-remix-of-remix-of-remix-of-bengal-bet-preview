import { expect, it } from 'vitest';
import { verifyVipTiers, verifyVipDeletion } from '../bengalbet/services/vipPersistence';

it('confirms VIP1 plan amounts only after matching readback', () => {
  const tier = { level: 1, targetBet: 20000, depositTarget: 2000, upgradeBonus: 50, weeklyBonus: 20, monthlyBonus: 50 };
  expect(verifyVipTiers({ success: true, tiers: [tier] }, [tier])).toEqual([tier]);
  expect(() => verifyVipTiers({ success: true, tiers: [{ ...tier, monthlyBonus: 49 }] }, [tier])).toThrow();
  expect(() => verifyVipTiers({ success: false, tiers: [tier] }, [tier])).toThrow();
});
it('does not confirm deletion while the tier remains', () => {
  expect(() => verifyVipDeletion({ success: true, tiers: [{ level: 1 }] }, 1)).toThrow();
  expect(verifyVipDeletion({ success: true, tiers: [{ level: 0 }] }, 1)).toEqual([{ level: 0 }]);
  expect(verifyVipDeletion({ success: true, tiers: [{ level: 1, status: 'inactive' }] }, 1)).toEqual([{ level: 1, status: 'inactive' }]);
});
it('requires all reset tiers and rejects unexpected tiers', () => {
  expect(() => verifyVipTiers({ success: true, tiers: [{ level: 0 }, { level: 1 }] }, [{ level: 0 }], true)).toThrow();
});