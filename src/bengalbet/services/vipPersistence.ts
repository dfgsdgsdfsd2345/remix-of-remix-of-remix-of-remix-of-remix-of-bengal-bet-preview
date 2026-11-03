type Tier = Record<string, unknown>;
const numericFields = ['level', 'targetBet', 'depositTarget', 'upgradeBonus', 'weeklyBonus', 'monthlyBonus', 'birthdayBonus', 'slotRebate', 'liveRebate'];

export function verifyVipTiers(response: { success?: boolean; tiers?: Tier[] }, expected: Tier[], exact = false): Tier[] {
  if (!response.success || !Array.isArray(response.tiers)) throw new Error('VIP তথ্য আবার পড়া যায়নি।');
  const actual = response.tiers;
  if (exact && actual.length !== expected.length) throw new Error('VIP রিসেটের তথ্য মেলেনি।');
  for (const wanted of expected) {
    const saved = actual.find(t => Number(t['level']) === Number(wanted['level']));
    if (!saved || Object.entries(wanted).some(([key, value]) => {
      if (key === 'targetBetDisplay') return false; // Formatting is server-owned, not a financial field.
      if (numericFields.includes(key)) return !Number.isFinite(Number(saved[key])) || Number(saved[key]) !== Number(value);
      return saved[key] !== value;
    })) throw new Error('VIP পরিবর্তন সার্ভারে মেলেনি। আবার পরীক্ষা করুন।');
  }
  return actual;
}

export function verifyVipDeletion(response: { success?: boolean; tiers?: Tier[] }, level: number): Tier[] {
  const tiers = verifyVipTiers(response, []);
  if (tiers.some(t => Number(t['level']) === level && t['status'] !== 'inactive')) throw new Error('VIP স্তর এখনও সার্ভারে সক্রিয় আছে।');
  return tiers;
}