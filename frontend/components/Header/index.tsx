'use client'

import { useAuthState } from '@/context/AuthContext';
import Link from 'next/link';

export const Header = (): React.JSX.Element => {
    const { user } = useAuthState();
    return (
        <div className="fixed top-0 left-0 w-full bg-pink-200 z-20">
            <div className="flex items-center min-h-[64px] px-4 max-w-6xl mx-auto">
                <Link href="/" className="text-white font-bold text-lg">ロゴ</Link>
                <div className="ml-auto flex gap-2">
                    {user ? (
                        <Link href="/mypage" className='p-2'>
                            <div className="text-white">
                                {user.name}
                            </div>
                        </Link>
                    ) : (
                        <>
                            <Link
                                href="/login"
                                className="inline-flex items-center px-4 py-2 border border-white text-white text-sm font-medium rounded hover:bg-white hover:text-green-900 transition"
                            >
                                ログイン
                            </Link>
                            <Link
                                href="/signup"
                                className="inline-flex items-center px-4 py-2 border border-white text-white text-sm font-medium rounded hover:bg-white hover:text-green-900 transition"
                            >
                                新規登録
                            </Link>
                        </>
                    )}
                </div>
            </div>
        </div>
    );
};
