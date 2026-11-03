import React, { useCallback, useEffect, useState } from 'react';
import { ChevronLeft, RefreshCw } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { OffersClaimPanel } from './OffersClaimPanel';
import { api } from '../services/api';
import { rebateTransactions } from '../services/rebateHistory';
import type { UserAccount } from '../types';

interface RebateMobileViewProps {
  user?: UserAccount;
  onSettled?: () => void;
  onBack: () => void;
  onClose?: () => void;
  showToast?: (msg: string) => void;
}

export const RebateMobileView: React.FC<RebateMobileViewProps> = ({ user, onSettled, onBack }) => {
  const [history, setHistory] = useState<Record<string, any>[]>([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const loadHistory = useCallback(async () => {
    setLoading(true); setError('');
    try {
      const result = await api.wallet.getTransactions('bonus');
      if (!result.success || !Array.isArray(result.transactions)) throw new Error('রিবেটের ইতিহাস পাওয়া যায়নি।');
      setHistory(rebateTransactions(result.transactions));
    } catch {
      setHistory([]); setError('রিবেটের ইতিহাস লোড হয়নি। আবার চেষ্টা করুন।');
    } finally { setLoading(false); }
  }, []);
  useEffect(() => { if (user?.isLoggedIn) void loadHistory(); }, [user?.isLoggedIn, loadHistory]);
  return (
    <div id="mobile-rebate-view" className="min-h-screen w-full bg-background text-foreground font-bengali">
      <header className="sticky top-0 z-30 flex items-center justify-between border-b border-border bg-card px-4 py-3">
        <Button variant="ghost" size="icon" onClick={onBack} aria-label="ফিরে যান" title="ফিরে যান"><ChevronLeft /></Button>
        <h1 className="text-lg font-bold">রিবেট</h1>
        <Button variant="ghost" size="icon" onClick={() => void loadHistory()} disabled={loading || !user?.isLoggedIn} aria-label="রিবেট ইতিহাস আবার পড়ুন" title="রিবেট ইতিহাস আবার পড়ুন"><RefreshCw className={loading ? 'animate-spin' : ''} /></Button>
      </header>
      {user?.isLoggedIn ? <>
        <OffersClaimPanel onSettled={() => { onSettled?.(); void loadHistory(); }} />
        <section aria-label="রিবেট ইতিহাস" className="mx-auto w-full max-w-lg space-y-3 px-4 py-5">
          <h2 className="text-sm font-bold">রিবেট ইতিহাস</h2>
          {loading ? <p role="status" className="text-sm text-muted-foreground">লোড হচ্ছে…</p> : error ? <p role="alert" className="text-sm text-destructive">{error}</p> : history.length === 0 ? <p className="text-sm text-muted-foreground">কোনো রিবেটের লেনদেন নেই।</p> : history.map(row => <article key={row['id']} className="flex items-center justify-between gap-3 border-b border-border py-3">
            <div className="min-w-0"><p className="text-sm font-semibold">রিয়েল টাইম রিবেট</p><p className="break-words text-xs text-muted-foreground">{row['createdAt'] ?? row['created_at'] ?? row['date']}</p></div>
            <span className="shrink-0 text-sm font-bold">+৳{Number(row['amount']).toLocaleString('bn-BD', { minimumFractionDigits: 2 })}</span>
          </article>)}
        </section>
      </> : <p className="px-4 py-6 text-sm text-muted-foreground">রিবেট দেখতে লগইন করুন।</p>}
    </div>
  );
};
