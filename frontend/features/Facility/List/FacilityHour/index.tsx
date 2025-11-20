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

  return (
    <div className="space-y-1">
      {facility.hours?.length ? (
        facility.hours.map(hour => (
          <div key={hour.id} className="flex justify-between text-gray-700 text-sm py-1">
            <span className="font-medium">{hour.day_of_week_label}</span>
            <span>
              {formatTime(hour.open_time)}〜{formatTime(hour.close_time)}
            </span>
          </div>
        ))
      ) : (
        <p className="text-gray-500 text-sm">営業時間情報は登録されていません。</p>
      )}
    </div>
  );
};
