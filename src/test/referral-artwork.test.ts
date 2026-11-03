import { expect, it } from 'vitest';
import { referralArtworkMatches } from '../bengalbet/services/referralArtwork';
it('shows printed referral artwork only for all three v8 rates', () => {
  const rates = { instantBonus: 300, depositRate: 0.7, betRate: 1 };
  expect(referralArtworkMatches(rates)).toBe(true);
  expect(referralArtworkMatches(null)).toBe(false);
  for (const key of Object.keys(rates)) expect(referralArtworkMatches({ ...rates, [key]: 0 })).toBe(false);
});