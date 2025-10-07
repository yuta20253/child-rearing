import React from 'react';

type TodayEvent = {
  title: string;
};

type Props = {
  todayEvent: TodayEvent;
};

export const TodayEventList = ({ todayEvent }: Props) => {
  return (
    <>
      <div className="text-blue-500 text-lg flex items-center justify-center w-10 h-10">Logo</div>
      <div className="flex flex-col justify-center">
        <p className="text-[10px] font-semibold">{todayEvent.title}</p>
        <p className="text-[10px] text-gray-500">予約</p>
      </div>
    </>
  );
};
