import Alpine from 'alpinejs';

Alpine.data('loanSimulator', () => ({
    amount: 1000,
    term: 12,
    savings: 0,
    boost: 0,
    calculate() {
        this.boost = this.savings * 0.5; // Matches SavingsCalculator
        return this.amount + this.boost;
    }
}));

Alpine.start();
