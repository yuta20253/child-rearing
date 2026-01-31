import { Facility } from '@/types/generated/api';
import { facilities, facility } from './apiClient';

type facilityDetailResponse = {
  facilityDetail: Facility;
  favorited: boolean;
};

export const getFacilities = async (token: string, name?: string): Promise<Facility[] | null> => {
  try {
    const response = await facilities.facilitiesInfo(
      { name },
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );

    const data = response.data.facilities;

    if (!data) return null;

    return data;
  } catch (error) {
    console.error(error);
    throw new Error('施設一覧の取得に失敗しました');
  }
};

export const getFacility = async (token: string, id: number): Promise<facilityDetailResponse> => {
  try {
    const response = await facility.facilityInfo(id, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    const facilityDetail = response.data.facility;
    const favorited = response.data.favorited;

    if (!facilityDetail) throw new Error('施設データが存在しません');

    return { facilityDetail, favorited };
  } catch (error) {
    console.log(error);
    const message =
      error instanceof Error
        ? error.message
        : typeof error === 'string'
          ? error
          : '不明なエラーが発生しました';
    throw new Error(message);
  }
};
