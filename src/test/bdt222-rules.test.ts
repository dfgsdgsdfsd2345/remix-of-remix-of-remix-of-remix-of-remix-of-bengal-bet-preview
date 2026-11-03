import { describe, it, expect } from 'vitest';
import { PROMO_RULE_DEFAULTS, validatePromoRules, slotDailyBonus, rebateRate } from '@/bengalbet/services/promoRules';
import { DEFAULT_DEPOSIT_OFFER, depositBonus, validateDepositOffer } from '@/bengalbet/services/depositOffer';

const r = validatePromoRules(PROMO_RULE_DEFAULTS);

describe('bdt222 reference rules', () => {
  it('first deposit steps: ৳100→47, ৳200→77, ৳500→177, ৳5,000→1,577, ৳1,00,000→37,777', () => {
    const o = validateDepositOffer(DEFAULT_DEPOSIT_OFFER);
    expect(depositBonus(o, 99, true, false)).toBe(0);
    expect(depositBonus(o, 100, true, false)).toBe(47);
    expect(depositBonus(o, 250, true, false)).toBe(77);
    expect(depositBonus(o, 500, true, false)).toBe(177);
    expect(depositBonus(o, 5000, true, false)).toBe(1577);
    expect(depositBonus(o, 200000, true, false)).toBe(37777);
  });
  it('daily slot bonus adds every reached step: ৳20,000 bets → ৳56', () => {
    expect(slotDailyBonus(r.slotDaily, 999)).toBe(0);
    expect(slotDailyBonus(r.slotDaily, 1000)).toBe(3);
    expect(slotDailyBonus(r.slotDaily, 20000)).toBe(56);
  });
  it('daily slot bonus total never exceeds ৳17,777', () => {
    expect(slotDailyBonus(r.slotDaily, 50000000)).toBe(17777);
  });
  it('rebate rate by lifetime bets: 0.3% → 0.6% at 10 lakh → 1.5% at 1 crore → 3% at 5 crore', () => {
    expect(rebateRate(r.rebate, 500)).toBe(0.3);
    expect(rebateRate(r.rebate, 1000000)).toBe(0.6);
    expect(rebateRate(r.rebate, 10000000)).toBe(1.5);
    expect(rebateRate(r.rebate, 50000000)).toBe(3);
  });
  it('rebate step above 3% is rejected', () => {
    expect(() => validatePromoRules({ ...PROMO_RULE_DEFAULTS, rebate: { enabled: true, ratePercent: 3, tiers: [{ bet: 1, ratePercent: 3.5 }] } })).toThrow();
  });
  it('lucky wheel ticket from a ৳300 daily deposit', () => {
    expect(r.wheelTicketMinDeposit).toBe(300);
  });
});
