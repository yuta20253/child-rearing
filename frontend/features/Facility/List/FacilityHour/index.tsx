import { FacilityWithRelations } from '@/types/generated/api';

type FacilityProps = {
  facility: FacilityWithRelations;
};

export const FacilityHourList = ({ facility }: FacilityProps) => {
  const formatTime = (time?: string) => {
    if (!time) return '—';
    const [h, m] = time.split(':');
    return `${Number(h)}:${m}`;
  };

  const hours = facility.hours ?? [];

  if (hours.length === 0) {
    return <p className="text-[11px] text-gray-400">営業時間情報は登録されていません。</p>;
  }

  return (
    <div className="space-y-1">
      {hours.map(hour => (
        <div
          key={hour.id}
          className="flex items-center justify-between rounded-lg px-3 py-2 bg-white"
        >
          <span className="inline-flex items-center justify-center rounded-full bg-gray-100 px-2.5 py-0.5 text-[11px] font-medium text-gray-700">
            {hour.day_of_week_label}
          </span>

          <span className="text-xs text-gray-800 tabular-nums">
            {formatTime(hour.open_time)}〜{formatTime(hour.close_time)}
          </span>
        </div>
      ))}
    </div>
  );
};
