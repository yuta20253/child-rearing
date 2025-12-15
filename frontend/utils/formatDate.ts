export function formatTime(dateTime: string): string {
  const [, time] = dateTime.split(' ');
  return time.slice(0, 5);
}

export function formatMonthDay(date: string): string {
  const [, month, day] = date.split('-');
  return `${Number(month)}月${Number(day)}日`;
}
