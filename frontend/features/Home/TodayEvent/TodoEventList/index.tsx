import React from 'react';
import { formatTime } from '@/utils/formatDate';

type TodayEvent = {
  title: string;
  start_datetime: string;
  end_datetime: string;
};

type Props = {
  todayEvent: TodayEvent;
};

export const TodayEventList = ({ todayEvent }: Props) => {
  return (
    <div className="flex items-center space-x-3">
      <div className="text-blue-500 text-lg flex items-center justify-center w-10 h-10">Logo</div>
      <div className="flex flex-col justify-center">
        <p className="text-sm font-semibold text-gray-800 leading-tight">{todayEvent.title}</p>
        <p className="text-xs text-gray-500 mt-[2px]">{formatTime(todayEvent.start_datetime)} ~ {formatTime(todayEvent.end_datetime)}</p>
      </div>
    </div>
  );
};
