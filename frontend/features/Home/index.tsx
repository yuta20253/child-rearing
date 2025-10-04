'use client'

import axios from 'axios';
import { useEffect, useState } from 'react';

type WeekDay = {
  date: string;
  day: string;
};

export const Home = (): React.JSX.Element => {
    const [week, SetWeek] = useState<WeekDay[]>([]);
    console.log(week);

    useEffect(() => {
        const fetchWeek = async () => {
            try {
                const res = await axios.get(process.env.NEXT_PUBLIC_BACKEND_URL + '/api');
                SetWeek(res.data.week);
            } catch (error) {
                console.error('曜日取得エラー:', error);
            }
        };
        fetchWeek();
    }, [])

    return (
        <div className="flex items-center justify-center  bg-gradient-to-tr">
            <div className="relative w-3/4 sm:max-w-md md:max-w-lg lg:max-w-xl p-4 sm:p-2 flex flex-col space-y-2">
                <div className="p-2">
                    <div className="items-center justify-center rounded-lg">
                        <p className="p-2 text-2xl text-center text-white bg-pink-200">子育てサポート</p>
                    </div>
                </div>
                {/** カレンダー部分 */}
                <div className="flex flex-col items-center justify-center rounded-lg mb-6">
                    <p className="text-center font-bold">{week.length > 0 ? new Date(week[0].date).getMonth() + 1 : '' }月 カレンダー/予定登録</p>
                    <div className="bg-yellow-50 m-4 p-4 rounded shadow w-full max-w-[700px] mx-auto overflow-x-auto">
                        <table className="table-fixed border-collapse text-center w-full">
                            <thead>
                                <tr>
                                    {week.map((day, i) => (
                                    <th
                                        key={i}
                                        className="w-[14.2857%] min-w-[60px] px-3 py-2 whitespace-nowrap"
                                    >
                                        {day['day']}
                                    </th>
                                    ))}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    {week.map((date, i) => (
                                    <td key={i} className="px-2 py-4 h-12">
                                        {
                                            date['date'].slice(-2).replace(/^0/, "")
                                        }
                                    </td>
                                    ))}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {/** イベント部分 */}
                <div className="mb-6">
                    <p className="font-bold mb-3">今日の予定</p>
                    <ul>
                        <li className="flex w-full items-center space-x-4 p-2 rounded shadow h-12">
                            <div className="text-blue-500 text-lg flex items-center justify-center w-10 h-10">Logo</div>
                            <div className="flex flex-col justify-center">
                                <p className="font-semibold">title</p>
                                <p className="text-sm text-gray-500">予約</p>
                            </div>
                        </li>
                    </ul>
                </div>
                {/** お気に入り施設 */}
                <div className="w-full max-w-[700px] mx-auto">
                    <p className="font-bold mb-3">お気に入り施設</p>
                    {
                        <div className="overflow-x-auto pb-2">
                            <div className="flex space-x-4 min-w-fit">
                                <div className="flex-shrink-0 w-[240px] bg-white border border-gray-300 rounded p-4 shadow ">
                                    <div className="flex flex-col justify-between pr-2">
                                        <p className="font-semibold">施設名</p>
                                        <p className="text-sm text-yellow-500">星評価</p>
                                    </div>
                                    <div>
                                        <p className="text-sm text-gray-600">施設タイプ</p>
                                        <p className="text-sm text-gray-600 mb-2">住所</p>
                                    </div>
                                    <div className="flex justify-end">
                                        <button className="text-sm text-blue-600 hover:underline">詳細を見る</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    }
                </div>
                <div className="w-full bg-pink-500 text-white p-4 rounded mt-6">
                    <div className="flex justify-center">
                        <button className="bg-white text-pink-500 font-semibold px-6 py-3 rounded">
                            施設を探す
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};
