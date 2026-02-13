import { cancel, register } from './apiClient';

export const registerFacilityFavorite = async (
  token: string,
  facilityId: number
): Promise<string> => {
  try {
    const response = await register.registerFacilityFavorite(facilityId, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    return response.data.message ?? '';
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

export const cancelFacilityFavorite = async (
  token: string,
  facilityId: number
): Promise<string> => {
  try {
    const res = await cancel.cancelFacilityFavorite(facilityId, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    return res.data.message ?? '';
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
