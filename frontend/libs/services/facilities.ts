import { FacilityWithRelations } from '@/types/generated/api';
import { facilities, facility } from './apiClient';

type facilityDetailResponse = {
  facilityDetail: FacilityWithRelations;
  isFavorite: boolean;
};

export const getFacilities = async (
  token: string,
  name?: string
): Promise<FacilityWithRelations[] | null> => {
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

    console.log(response.data);
    const facilityDetail = response.data.facility;
    const isFavorite = response.data.isFavorite;

    if (!facilityDetail) throw new Error('施設データが存在しません');

    return { facilityDetail, isFavorite };
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
