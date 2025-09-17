import axios from 'axios';

export const getCurrentUser = async (token: string) => {
    try {
        const res = await axios.get('http://localhost:8000/api/profile', {
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
