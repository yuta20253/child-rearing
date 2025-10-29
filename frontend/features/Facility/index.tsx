'use client';

import { RequireAuth } from "@/components/RequireAuth";
import { useState, useEffect } from "react";
import dynamic from 'next/dynamic';
import { FacilityWithRelations } from "@/types/generated/api";
import { getFacility } from "@/libs/services/facilities";

const Map = dynamic(() => import('./Map').then(mod => mod.Map), { ssr: false });

export const FacilityPage = ({ id }: {id: string}): React.JSX.Element => {
    const [isLoading, setIsLoading] = useState<boolean>(false);
    const [facility, setFacility] = useState<FacilityWithRelations | undefined>(undefined);

    console.log(facility);
    useEffect(() => {
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
                            <div className="justify-between p-4">
                                <div className="">
                                    <div className="">住所</div>
                                    <div className="pl-2">{facility.address?.municipality?.prefecture?.name || '' + facility.address?.municipality?.name + facility.address?.town}</div>
                                </div>
                                <div className="">電話番号</div>
                                <div className="">営業時間</div>
                                <div className="">
                                    <div className="">設備情報</div>
                                    <div className="pl-2">{facility.equipment}</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>💬口コミ</p>
                            {
                                facility.reviews?.map((review) => (
                                    <div key={review.id}>
                                        <p>{review.rating}</p>
                                        <div>{review.user?.name}</div>
                                        <div>{review.comment}</div>
                                    </div>
                                ))
                            }
                        </div>
                    </div>
                ) : (
                    <div></div>
                )}
            </div>
        </RequireAuth>
    );
};
