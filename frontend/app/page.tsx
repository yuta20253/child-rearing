'use client';

import { useEffect, useState } from 'react';
import axios from 'axios';

const HomePage = () => {
    const [data, setData] = useState<{ message: string } | null>(null);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        // Laravel API エンドポイントを呼び出し
        axios
            .get(process.env.NEXT_PUBLIC_BACKEND_URL + '/test')  // Laravel API の URL
            .then((response) => {
                setData(response.data);  // レスポンスのデータをステートに保存
            })
            .catch((err) => {
                setError(err.message);  // エラーメッセージをステートに保存
            });
    }, []);

    return (
        <div>
            <h1>Next.js + Laravel Test</h1>
            {error && <p style={{ color: 'red' }}>Error: {error}</p>}
            {data ? (
                <p>{data.message}</p>  // Laravel から受け取ったメッセージを表示
            ) : (
                <p>Loading...</p>
            )}
        </div>
    );
};

export default HomePage;
