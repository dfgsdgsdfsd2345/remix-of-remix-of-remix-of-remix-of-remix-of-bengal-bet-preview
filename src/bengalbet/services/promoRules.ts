/** Admin-editable promotion rules. Must stay identical to server/dbserver/api/promo_rules.php. */
export interface PromoRules {
  loginHammerPerDay: number;
  depositEggsPerDay: number;
  wheelTicketMinDeposit: number;
  wheelTicketsPerDay: number;
  redPacket: { enabled: boolean; hours: number[]; durationMinutes: number; perRoundLimit: number };
  rescue: { enabled: boolean; claimDeadlineHour: number; categories: string[] };
  vip: { weeklyClaimDay: number; monthlyClaimDay: number; monthlyHour: number };
  appBonus: { enabled: boolean; amount: number };
  slotDaily: { enabled: boolean; minBet: number; ratePercent: number; maxBonus: number; claimFromHour: number; tiers?: { bet: number; bonus: number }[] };
  rebate: { enabled: boolean; ratePercent: number; tiers?: { bet: number; ratePercent: number }[] };
  memberDay: { enabled: boolean; day: number; minBet: number; ratePercent: number; maxBonus: number };
  withdrawal: { enabled: boolean; depositTurnover: number; depositBonusTurnover: number; otherBonusTurnover: number };
  missions: { enabled: boolean; category: string; tiers: { bet: number; bonus: number }[] };
  referralLevels: { enabled: boolean; tiers: { friends: number; bonus: number }[] };
}

/** bdt222 reference: daily slot bet steps; reached steps add up (cap = slotDaily.maxBonus). */
export const SLOT_DAILY_TIERS = ([[1000, 3], [3000, 8], [5000, 12], [10000, 15], [20000, 18], [30000, 21], [40000, 25], [50000, 28], [60000, 31], [70000, 35], [80000, 38], [90000, 41], [100000, 45], [200000, 100], [300000, 200], [400000, 300], [500000, 400], [600000, 500], [700000, 600], [800000, 700], [900000, 800], [1000000, 900], [2000000, 2777], [3000000, 3777], [5000000, 7777], [10000000, 17777]] as [number, number][]).map(([bet, bonus]) => ({ bet, bonus }));
/** bdt222 reference: rebate rate by the member's lifetime valid bets. */
export const REBATE_TIERS = [{ bet: 1, ratePercent: 0.3 }, { bet: 1000000, ratePercent: 0.6 }, { bet: 10000000, ratePercent: 1.5 }, { bet: 50000000, ratePercent: 3 }];

export const PROMO_RULE_DEFAULTS: PromoRules = {
  loginHammerPerDay: 1,
  depositEggsPerDay: 3,
  wheelTicketMinDeposit: 300,
  wheelTicketsPerDay: 1,
  redPacket: { enabled: true, hours: [0, 12, 16, 20], durationMinutes: 30, perRoundLimit: 50 },
  rescue: { enabled: true, claimDeadlineHour: 10, categories: ['slot', 'fishing'] },
  vip: { weeklyClaimDay: 1, monthlyClaimDay: 1, monthlyHour: 15 },
  appBonus: { enabled: true, amount: 52 },
  slotDaily: { enabled: true, minBet: 1000, ratePercent: 0, maxBonus: 17777, claimFromHour: 9, tiers: SLOT_DAILY_TIERS },
  rebate: { enabled: true, ratePercent: 3, tiers: REBATE_TIERS },
  memberDay: { enabled: true, day: 13, minBet: 1000, ratePercent: 1, maxBonus: 100000 },
  withdrawal: { enabled: true, depositTurnover: 1, depositBonusTurnover: 19, otherBonusTurnover: 1 },
  missions: { enabled: true, category: 'slot', tiers: [{ bet: 1000, bonus: 3 }, { bet: 3000, bonus: 8 }, { bet: 5000, bonus: 12 }, { bet: 10000, bonus: 18 }, { bet: 20000, bonus: 56 }, { bet: 50000, bonus: 128 }, { bet: 100000, bonus: 268 }, { bet: 200000, bonus: 588 }, { bet: 500000, bonus: 1288 }, { bet: 1000000, bonus: 2888 }, { bet: 2000000, bonus: 5888 }, { bet: 5000000, bonus: 12888 }, { bet: 10000000, bonus: 17777 }, { bet: 15000000, bonus: 22888 }, { bet: 20000000, bonus: 28888 }, { bet: 25000000, bonus: 35888 }, { bet: 30000000, bonus: 42888 }, { bet: 40000000, bonus: 55888 }, { bet: 50000000, bonus: 68888 }, { bet: 60000000, bonus: 82888 }, { bet: 70000000, bonus: 98888 }, { bet: 80000000, bonus: 118888 }, { bet: 90000000, bonus: 138888 }, { bet: 100000000, bonus: 168888 }, { bet: 150000000, bonus: 218888 }, { bet: 200000000, bonus: 300000 }] },
  referralLevels: { enabled: true, tiers: [{ friends: 10, bonus: 1500 }, { friends: 15, bonus: 1500 }, { friends: 20, bonus: 1500 }, { friends: 30, bonus: 3000 }, { friends: 40, bonus: 3000 }, { friends: 50, bonus: 3000 }, { friends: 60, bonus: 3000 }, { friends: 70, bonus: 3000 }, { friends: 80, bonus: 3000 }, { friends: 90, bonus: 3000 }, { friends: 100, bonus: 10000 }, { friends: 150, bonus: 15000 }, { friends: 200, bonus: 15000 }, { friends: 250, bonus: 15000 }, { friends: 300, bonus: 15000 }, { friends: 350, bonus: 15000 }, { friends: 400, bonus: 15000 }, { friends: 500, bonus: 15000 }, { friends: 600, bonus: 30000 }, { friends: 700, bonus: 30000 }, { friends: 800, bonus: 30000 }, { friends: 1000, bonus: 60000 }, { friends: 1500, bonus: 150000 }, { friends: 2000, bonus: 150000 }, { friends: 2500, bonus: 150000 }, { friends: 3000, bonus: 150000 }, { friends: 4000, bonus: 300000 }, { friends: 5000, bonus: 300000 }, { friends: 6000, bonus: 300000 }, { friends: 7000, bonus: 300000 }, { friends: 8000, bonus: 300000 }, { friends: 9000, bonus: 300000 }, { friends: 10000, bonus: 300000 }, { friends: 11000, bonus: 300000 }, { friends: 12000, bonus: 300000 }, { friends: 13000, bonus: 300000 }, { friends: 14000, bonus: 300000 }, { friends: 15000, bonus: 300000 }, { friends: 20000, bonus: 1500000 }, { friends: 25000, bonus: 1500000 }, { friends: 30000, bonus: 1500000 }, { friends: 35000, bonus: 1500000 }, { friends: 40000, bonus: 1500000 }, { friends: 50000, bonus: 3000000 }, { friends: 60000, bonus: 3000000 }, { friends: 70000, bonus: 3000000 }, { friends: 80000, bonus: 3000000 }, { friends: 90000, bonus: 3000000 }, { friends: 100000, bonus: 3000000 }] },
};

export const GAME_CATEGORIES = ['slot', 'fishing', 'live', 'crash', 'table', 'arcade', 'poker', 'sports', 'esports', 'lottery'];

const int = (v: unknown, min: number, max: number) => {
  if (typeof v !== 'number' || !Number.isInteger(v) || v < min || v > max) throw new Error('প্রোমোশন নিয়মের সংখ্যা সঠিক নয়।');
  return v;
};
const num = (v: unknown, min: number, max: number) => {
  if (typeof v !== 'number' || !Number.isFinite(v) || v < min || v > max) throw new Error('প্রোমোশন নিয়মের সংখ্যা সঠিক নয়।');
  return Math.round(v * 100) / 100;
};
const bool = (v: unknown) => { if (typeof v !== 'boolean') throw new Error('প্রোমোশন নিয়ম সঠিক নয়।'); return v; };

function tiers<K extends string>(t: unknown, key: K, max: number): ({ [P in K]: number } & { bonus: number })[] {
  if (!Array.isArray(t) || t.length < 1 || t.length > 60) throw new Error('ধাপ ১–৬০টি হতে হবে।');
  let prev = -1;
  return t.map((x: any) => {
    const n = num(x?.[key], 1, max);
    if (n <= prev) throw new Error('ধাপগুলো ছোট থেকে বড় ক্রমে দিন।');
    prev = n;
    return { [key]: n, bonus: num(x?.bonus, 0, 1e7) } as any;
  });
}

function rateTiers(t: unknown): { bet: number; ratePercent: number }[] {
  if (!Array.isArray(t) || t.length > 40) throw new Error('রিবেট ধাপ ০–৪০টি হতে হবে।');
  let prev = -1;
  return t.map((x: any) => {
    const bet = num(x?.bet, 1, 1e11);
    if (bet <= prev) throw new Error('ধাপগুলো ছোট থেকে বড় ক্রমে দিন।');
    prev = bet;
    return { bet, ratePercent: num(x?.ratePercent, 0, 3) };
  });
}

export function validatePromoRules(c: PromoRules): PromoRules {
  if (!c || !c.redPacket || !c.rescue || !c.vip || !c.appBonus || !c.slotDaily || !c.rebate || !c.memberDay || !c.withdrawal) throw new Error('প্রোমোশন নিয়ম সঠিক নয়।');
  if (!Array.isArray(c.redPacket.hours) || c.redPacket.hours.length < 1 || c.redPacket.hours.length > 24) throw new Error('রেড প্যাকেটের অন্তত একটি সময় দিন।');
  const hours = [...new Set(c.redPacket.hours.map((h) => int(h, 0, 23)))].sort((a, b) => a - b);
  if (!Array.isArray(c.rescue.categories) || !c.rescue.categories.length || c.rescue.categories.some((x) => !GAME_CATEGORIES.includes(x))) throw new Error('উদ্ধার তহবিলের অন্তত একটি গেম ধরন দিন।');
  const amount = c.appBonus.amount;
  if (typeof amount !== 'number' || !Number.isFinite(amount) || amount < 0 || amount > 100000) throw new Error('অ্যাপ বোনাস ০–১,০০,০০০ হতে হবে।');
  return {
    loginHammerPerDay: int(c.loginHammerPerDay, 0, 10),
    depositEggsPerDay: int(c.depositEggsPerDay, 0, 20),
    wheelTicketMinDeposit: int(c.wheelTicketMinDeposit, 0, 10000000),
    wheelTicketsPerDay: int(c.wheelTicketsPerDay, 0, 10),
    redPacket: { enabled: bool(c.redPacket.enabled), hours, durationMinutes: int(c.redPacket.durationMinutes, 1, 59), perRoundLimit: int(c.redPacket.perRoundLimit, 1, 100000) },
    rescue: { enabled: bool(c.rescue.enabled), claimDeadlineHour: int(c.rescue.claimDeadlineHour, 1, 24), categories: [...new Set(c.rescue.categories)] },
    vip: { weeklyClaimDay: int(c.vip.weeklyClaimDay, 1, 7), monthlyClaimDay: int(c.vip.monthlyClaimDay, 1, 28), monthlyHour: int(c.vip.monthlyHour ?? 15, 0, 23) },
    appBonus: { enabled: bool(c.appBonus.enabled), amount: Math.round(amount * 100) / 100 },
    slotDaily: { enabled: bool(c.slotDaily.enabled), minBet: num(c.slotDaily.minBet, 0, 1e8), ratePercent: num(c.slotDaily.ratePercent, 0, 100), maxBonus: num(c.slotDaily.maxBonus, 0, 1e8), claimFromHour: int(c.slotDaily.claimFromHour, 0, 23), tiers: c.slotDaily.tiers === undefined ? (PROMO_RULE_DEFAULTS.slotDaily.tiers ?? []) : (c.slotDaily.tiers.length ? tiers(c.slotDaily.tiers, 'bet', 1e10) : []) },
    rebate: { enabled: bool(c.rebate.enabled), ratePercent: num(c.rebate.ratePercent, 0, 3), tiers: rateTiers(c.rebate.tiers ?? REBATE_TIERS) },
    memberDay: { enabled: bool(c.memberDay.enabled), day: int(c.memberDay.day, 2, 28), minBet: num(c.memberDay.minBet, 0, 1e8), ratePercent: num(c.memberDay.ratePercent, 0, 100), maxBonus: num(c.memberDay.maxBonus, 0, 1e8) },
    withdrawal: { enabled: bool(c.withdrawal.enabled), depositTurnover: num(c.withdrawal.depositTurnover, 0, 50), depositBonusTurnover: num(c.withdrawal.depositBonusTurnover, 0, 50), otherBonusTurnover: num(c.withdrawal.depositTurnover, 0, 50) },
    missions: (() => { const m = c.missions ?? PROMO_RULE_DEFAULTS.missions; if (!['all', ...GAME_CATEGORIES].includes(m.category)) throw new Error('মিশনের গেম ধরন সঠিক নয়।'); return { enabled: bool(m.enabled), category: m.category, tiers: tiers(m.tiers, 'bet', 1e10) }; })(),
    referralLevels: (() => { const m = c.referralLevels ?? PROMO_RULE_DEFAULTS.referralLevels; return { enabled: bool(m.enabled), tiers: tiers(m.tiers, 'friends', 100000) }; })(),
  };
}

/** Base on every new non-game credit; extra only on first-deposit bonus. */
export function remainingTurnover(rules: PromoRules['withdrawal'], deposits: number, depositBonus: number, otherBonus: number, bets: number, firstDepositBonus = depositBonus): number {
  if (!rules.enabled) return 0;
  const required = (deposits + depositBonus + otherBonus) * rules.depositTurnover + firstDepositBonus * rules.depositBonusTurnover;
  return Math.max(0, Math.round((required - bets) * 100) / 100);
}

/** Bonus = turnover × rate, capped; zero below the minimum turnover. Same formula on the server. */
export function turnoverBonus(turnover: number, minBet: number, ratePercent: number, maxBonus: number): number {
  if (!Number.isFinite(turnover) || turnover <= 0 || turnover < minBet) return 0;
  const b = Math.round(turnover * ratePercent) / 100;
  return Math.round((maxBonus > 0 ? Math.min(b, maxBonus) : b) * 100) / 100;
}

/** Daily slot bonus: with steps, every reached step adds its bonus (capped); otherwise the percentage formula. */
export function slotDailyBonus(c: PromoRules['slotDaily'], turnover: number): number {
  if (!c.tiers?.length) return turnoverBonus(turnover, c.minBet, c.ratePercent, c.maxBonus);
  if (!Number.isFinite(turnover) || turnover < c.minBet) return 0;
  const sum = c.tiers.filter((t) => turnover >= t.bet).reduce((a, t) => a + t.bonus, 0);
  return Math.round((c.maxBonus > 0 ? Math.min(sum, c.maxBonus) : sum) * 100) / 100;
}

/** Rebate rate for a member's lifetime valid bets: highest reached step, else the flat rate. */
export function rebateRate(c: PromoRules['rebate'], lifetimeBets: number): number {
  if (!c.tiers?.length) return c.ratePercent;
  let rate = 0;
  for (const t of c.tiers) if (lifetimeBets >= t.bet) rate = t.ratePercent;
  return rate;
}

/** Red packet round key for a Bangladesh-time hour/minute, or null when no round is open. */
export function packetRound(rules: PromoRules, hour: number, minute: number): number | null {
  if (!rules.redPacket.enabled) return null;
  return rules.redPacket.hours.includes(hour) && minute < rules.redPacket.durationMinutes ? hour : null;
}

export async function savePromoRules(rules: PromoRules, service: {
  updateRules: (r: PromoRules) => Promise<{ success: boolean }>;
  getRules: () => Promise<{ success: boolean; rules: PromoRules }>;
}) {
  const clean = validatePromoRules(rules);
  if (!(await service.updateRules(clean)).success) throw new Error('প্রোমোশন নিয়ম সংরক্ষণ হয়নি।');
  const back = await service.getRules();
  if (!back.success || JSON.stringify(back.rules) !== JSON.stringify(clean)) throw new Error('সার্ভারে সংরক্ষিত নিয়ম মিলছে না।');
  return back.rules;
}
