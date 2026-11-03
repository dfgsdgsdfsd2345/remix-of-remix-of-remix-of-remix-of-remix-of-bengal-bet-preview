import { expect, it } from 'vitest';
import { rebateTransactions } from '../bengalbet/services/rebateHistory';
it('shows only settled member rebate ledger records, without inventing history', () => {
  const rebate = { id: 'rebate-1', type: 'bonus', status: 'success', amount: 606, description: 'রিয়েল টাইম রিবেট ৳606' };
  expect(rebateTransactions([rebate, { ...rebate, type: 'deposit' }, { ...rebate, status: 'pending' }, { ...rebate, description: 'রেফার বোনাস' }])).toEqual([rebate]);
  expect(rebateTransactions(undefined)).toEqual([]);
});