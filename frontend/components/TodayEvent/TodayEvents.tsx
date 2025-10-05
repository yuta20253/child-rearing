import React, { useState } from "react";

import { TodayEventList } from "./TodayEventList";

type TodayEvent = {
  title: string;
};

type Props = {
  todayEvents: TodayEvent[];
};

export const TodayEvents = ({ todayEvents }: Props):React.JSX.Element => {
    const [showAll, setShowAll] = useState<boolean>(false);
    return (
        <div className="mb-6">
            <p className="font-bold mb-3">今日の予定</p>
            <ul>
                { todayEvents.length === 0 && (
                    <p className='text-center text-gray-500'>本日の予定はありません。</p>
                )}
                { todayEvents.length !== 0 && !showAll && (
                    todayEvents.slice(0, 3).map((event, i) => (
                    <li key={i} className={`flex w-full items-center space-x-4 p-2 rounded shadow h-12 ${i % 2 === 0 ? 'bg-yellow-50' : 'bg-blue-50'}`}>
                        <TodayEventList todayEvent={event} />
                    </li>
                    ))
                )}
                {todayEvents.length > 3 && !showAll && (
                    <div className="flex justify-center mt-2">
                        <button onClick={() => setShowAll(true)} className="text-sm text-blue-600 hover:underline">
                            その他を表示
                        </button>
                    </div>
                )}
                {showAll && (
                    <>
                        {todayEvents.map((event, i) => (
                        <li
                            key={i}
                            className={`flex w-full items-center space-x-4 p-2 rounded shadow h-12 ${i % 2 === 0 ? 'bg-yellow-50' : 'bg-blue-50'}`}
                        >
                            <TodayEventList todayEvent={event} />
                        </li>
                        ))}
                        <div className="flex justify-center mt-2">
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
    )
}
