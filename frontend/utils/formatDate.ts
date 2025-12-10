export function formatTime(dateTime: string): string {
  const [, time] = dateTime.split(" ");
  return time.slice(0, 5);
}
