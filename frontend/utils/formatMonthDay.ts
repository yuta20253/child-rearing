export function formatMonthDay(date: string): string {
    const [, month, day] = date.split('-');
    return `${Number(month)}月${Number(day)}日`;
}
