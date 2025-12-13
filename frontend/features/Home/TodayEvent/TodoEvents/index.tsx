import React, { useState } from 'react';
import { TodayEventList } from '@/features/Home/TodayEvent/TodoEventList';
import { formatMonthDay } from '@/utils/formatMonthDay';

type TodayEvent = {
  title: string;
  start_datetime: string;
  end_datetime: string;
};

type Props = {
  todayEvents: TodayEvent[];
  selectedDate: string;
};

export const TodayEvents = ({ todayEvents, selectedDate }: Props): React.JSX.Element => {
  const [showAll, setShowAll] = useState<boolean>(false);
  return (
    <div className="w-full max-w-[700px] mx-auto mb-8">
      <p className="font-bold mb-4">{formatMonthDay(selectedDate)}の予定</p>
      <ul className="space-y-3">
        {todayEvents.length === 0 && (
          <p className="text-center text-gray-500">{formatMonthDay(selectedDate)}の予定はありません。</p>
        )}
        {todayEvents.length !== 0 &&
          !showAll &&
          todayEvents.slice(0, 3).map((event, i) => (
            <li
              key={i}
              className={`flex w-full items-center p-3 rounded shadow ${i % 2 === 0 ? 'bg-yellow-50' : 'bg-blue-50'}`}
            >
              <TodayEventList todayEvent={event} />
            </li>
          ))}
        {todayEvents.length > 3 && !showAll && (
          <div className="flex justify-center mt-3">
            <button
              onClick={() => setShowAll(true)}
              className="text-sm text-blue-600 hover:underline"
            >
              その他を表示
            </button>
          </div>
        )}
        {showAll && (
          <>
            {todayEvents.map((event, i) => (
              <li
                key={i}
                className={`flex w-full items-center p-3 rounded shadow ${i % 2 === 0 ? 'bg-yellow-50' : 'bg-blue-50'}`}
              >
                <TodayEventList todayEvent={event} />
              </li>
            ))}
            <div className="flex justify-center mt-3">
              <button
                onClick={() => setShowAll(false)}
                className="text-sm text-blue-600 hover:underline"
              >
                閉じる
              </button>
            </div>
          </>
        )}
      </ul>
    </div>
  );
};
