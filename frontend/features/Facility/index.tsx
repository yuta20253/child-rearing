'use client';

import { RequireAuth } from "@/components/RequireAuth";
import { useState, useEffect } from "react";
import dynamic from 'next/dynamic';
import { Facility } from "@/types/generated/api";
import { getFacility } from "@/libs/services/facilities";

const Map = dynamic(() => import('./Map').then(mod => mod.Map), { ssr: false });

export const FacilityPage = ({ id }: {id: string}): React.JSX.Element => {
    const [isLoading, setIsLoading] = useState<boolean>(false);
    const [facility, setFacility] = useState<Facility | undefined>(undefined);

    useEffect(() => {
        console.log('id', id);
        const facilityId = Number(id);
        if (isNaN(facilityId)) return console.error('無効な施設IDです');
        const token = localStorage.getItem('token');
        if (!token) return;
        const fetchData = async () => {
            try {
                setIsLoading(true);

                const data = await getFacility(token, facilityId);

                if (data) {
                    setFacility(data);
                }
            } catch (error) {
                console.error('施設情報の取得に失敗しました', error);
            } finally {
                setIsLoading(false);
            }
        };
        fetchData();
    }, [id])
    return (
        <RequireAuth>
            <div className="">
                {!isLoading && facility ? (
                    <div>
                        <div className="text-center my-6">
                            <div className="max-w-[400px] mx-auto mt-4 text-left">
                                <p className="mb-1 font-bold">🗾 地図で見る</p>
                                <div className="flex space-x-2 border">
                                    <Map facility={facility} />
                                </div>
                            </div>
                        </div>
                        <div className="text-center">
                            <p className="text-2xl">🏠 {facility.name}</p>
                        </div>
                        <div className="mt-6 w-full max-w-md mx-auto space-y-4">
                            <div className="flex justify-between bg-white shadow rounded p-4">
                                <div className="w-1/2 pr-2">
                                    <div className="font-semibold">住所</div>
                                    <div></div>
                                </div>
                                <div className="w-1/2 pl-2">
                                    <div className="font-semibold">電話番号</div>
                                    <div></div>
                                </div>
                            </div>
                            <div className="flex justify-between bg-white shadow rounded p-4">
                                <div className="w-1/2 pr-2">
                                    <div className="font-semibold">営業時間</div>
                                    <div></div>
                                </div>
                                <div className="w-1/2 pl-2">
                                    <div className="font-semibold">設備情報</div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                ) : (
                    <div></div>
                )}
            </div>
        </RequireAuth>
    );
};
