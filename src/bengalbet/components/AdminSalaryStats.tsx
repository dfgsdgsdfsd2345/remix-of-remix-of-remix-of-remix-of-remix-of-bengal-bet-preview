// @ts-nocheck
import React, { useEffect, useState } from 'react';
import { api } from '../services/api';

/** Read-only VIP salary-card report straight from server card records. */
export default function AdminSalaryStats() {
  const [data, setData] = useState<any>(null);
  const [error, setError] = useState('');
  const load = () => { setError(''); api.salaryStats().then(setData).catch((e) => setError(e?.message || 'লোড হয়নি')); };
  useEffect(load, []);
  const label = (t: string) => (t === 'monthly' ? 'মাসিক' : t === 'weekly' ? 'সাপ্তাহিক' : t);
  return (
    <div className="bg-slate-900/90 border border-slate-800 rounded-2xl p-4 sm:p-5 shadow-xl">
      <div className="flex items-center justify-between mb-3">
        <h3 className="text-base font-bold text-white">ভিআইপি বেতন কার্ড পরিসংখ্যান</h3>
        <button onClick={load} className="text-xs px-3 py-1 rounded-lg bg-slate-800 text-slate-200">রিফ্রেশ</button>
      </div>
      {error && <p className="text-xs text-red-400">{error}</p>}
      {!data && !error && <p className="text-xs text-slate-400">লোড হচ্ছে…</p>}
      {data && data.periods.length === 0 && <p className="text-xs text-slate-400">এখনও কোনো বেতন কার্ড ইস্যু হয়নি।</p>}
      {data && data.periods.length > 0 && (
        <div className="overflow-x-auto">
          <table className="w-full text-xs text-slate-300">
            <thead><tr className="text-slate-400 text-left"><th className="py-1">ধরন</th><th>সময়কাল</th><th>ইস্যু</th><th>দাবি</th><th>ইস্যু ৳</th><th>পরিশোধিত ৳</th></tr></thead>
            <tbody>
              {data.periods.map((p: any) => (
                <tr key={p.type + p.period} className="border-t border-slate-800">
                  <td className="py-1">{label(p.type)}</td><td>{p.period}</td><td>{p.issued}</td><td>{p.claimed}</td>
                  <td>{p.issuedAmount.toFixed(2)}</td><td>{p.claimedAmount.toFixed(2)}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
}
