/** The bundled referral artwork prints all three reward rates. Missing live data hides it. */
export function referralArtworkMatches(rates: { instantBonus?: unknown; depositRate?: unknown; betRate?: unknown } | null | undefined): boolean {
  return !!rates && Number(rates.instantBonus) === 300 && Number(rates.depositRate) === 0.7 && Number(rates.betRate) === 1;
}