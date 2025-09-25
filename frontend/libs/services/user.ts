import axios from 'axios';

export const getCurrentUser = async (token: string) => {
    try {
        const res = await axios.get(process.env.NEXT_PUBLIC_BACKEND_URL + '/api/profile', {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json',
            },
        });
        return res.data.user;
    } catch (error) {
        console.error('ユーザー取得失敗', error);
        throw error;
    }
};
