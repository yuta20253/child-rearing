import React, { useState } from 'react';
import { Event } from '@/features/Home/Event';
import { formatMonthDay } from '@/utils/formatMonthDay';

type EventType = {
  title: string;
  start_datetime: string;
  end_datetime: string;
};

type Props = {
  events: EventType[];
  selectedDate: string;
};

export const Events = ({ events, selectedDate }: Props): React.JSX.Element => {
  const [showAll, setShowAll] = useState<boolean>(false);
  return (
    <div className="w-full max-w-[700px] mx-auto mb-8">
      <p className="font-bold mb-4">{formatMonthDay(selectedDate)}の予定</p>
      <ul className="space-y-3">
        {events.length === 0 && (
          <p className="text-center text-gray-500">
            {formatMonthDay(selectedDate)}の予定はありません。
          </p>
        )}
        {events.length !== 0 &&
          !showAll &&
          events.slice(0, 3).map((event, i) => (
            <li
              key={i}
              className={`flex w-full items-center p-3 rounded shadow ${i % 2 === 0 ? 'bg-yellow-50' : 'bg-blue-50'}`}
            >
              <Event event={event} />
            </li>
          ))}
        {events.length > 3 && !showAll && (
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
            {events.map((event, i) => (
              <li
                key={i}
                className={`flex w-full items-center p-3 rounded shadow ${i % 2 === 0 ? 'bg-yellow-50' : 'bg-blue-50'}`}
              >
                <Event event={event} />
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
