import { computed, isRef } from 'vue';
export const useMonthlyPayment = (total, interestRate, duration) => {
    const monthlyPayment = computed(() => {
        const principle = isRef(total) ? total.value : parseInt(total);
        const monthlyInterest = (isRef(interestRate) ? interestRate.value : interestRate) / 100 / 12;
        const numberOfPaymentMonths = (isRef(duration) ? duration.value : duration) * 12;
        return principle * monthlyInterest * (Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) / (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1);
    });

    const totalPaid = computed(() => {
        return monthlyPayment.value * (isRef(duration) ? duration.value : duration) * 12;
    });

    const totalInterest = computed(() => {
        return totalPaid.value - (isRef(total) ? total.value : total)
    });

    return { monthlyPayment, totalPaid, totalInterest }
}
