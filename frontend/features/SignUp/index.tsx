import { useForm, SubmitHandler } from 'react-hook-form';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { useState } from 'react';
import { useAuthActions } from '@/context/AuthContext';
import { TextField } from '@/components/TextField';

type SignUpForm = {
  email: string;
  password: string;
  password_confirmation: string;
};

export const SignUp = (): React.JSX.Element => {
    const [errorMessage, setErrorMessage] = useState<string>('');
    const router = useRouter();
    const { signUp } = useAuthActions();
    const { register, handleSubmit, watch, formState: { errors } } = useForm<SignUpForm>();

    const password = watch('password');

    const onSubmit: SubmitHandler<SignUpForm> = async (data: SignUpForm) => {
        const { email, password, password_confirmation } = data;
        const name = email.split('@')[0];
         try {
            await signUp({email, password, password_confirmation, name});
            router.push('/mypage');
        } catch (error) {
            const message =
              error instanceof Error
                ? error.message
                : typeof error === 'string'
                ? error
                : '不明なエラーが発生しました';
            setErrorMessage(message);
        }
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gradient-to-tr px-4 py-12">
            <div className="relative w-full sm:max-w-md md:max-w-lg lg:max-w-xl bg-white/60 backdrop-blur-md rounded-3xl shadow-2xl p-8 sm:p-10 flex flex-col space-y-6 animate-fadeIn">
                <h1 className="text-3xl sm:text-4xl font-extrabold text-center text-gray-800 tracking-tight">
                    新規登録
                </h1>
                {errorMessage && (
                <div className="flex items-center p-3 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 animate-pulse">
                    <svg className="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-9-4h2v5H9V6zm0 6h2v2H9v-2z" clipRule="evenodd" />
                    </svg>
                    <span>{errorMessage}</span>
                </div>
                )}
                <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col space-y-5">
                    <TextField
                        id='email'
                        label='メールアドレス'
                        type='email'
                        placeholder="example@mail.com"
                        {...register('email', {
                            required: 'メールアドレスを入力してください',
                            pattern: {
                            value: /^[\w.-]+@[\w.-]+\.[A-Za-z]{2,}$/,
                            message: 'メールアドレスの形式が正しくありません',
                            },
                        })}
                        error={errors.email}
                    />
                    <TextField
                        id='password'
                        label='パスワード'
                        type='password'
                        placeholder='********'
                        {...register('password', {
                            required: 'パスワードを入力してください',
                            minLength: { value: 8, message: '8文字以上で入力してください' },
                        })}
                        error={errors.password}
                    />
                    <TextField
                        id='password_confirmation'
                        label='パスワード(確認用)'
                        type='password'
                        placeholder='********'
                        {...register('password_confirmation', {
                            required: 'パスワードを入力してください',
                            minLength: { value: 8, message: '8文字以上で入力してください' },
                            validate: value => value === password || '入力されたパスワードと一致しません',
                        })}
                        error={errors.password_confirmation}
                    />
                <button
                    type="submit"
                    className="w-full py-3 bg-gradient-to-r bg-pink-300 text-white text-lg font-semibold rounded-2xl shadow-xl hover:shadow-2xl hover:scale-105 transition-transform duration-300"
                >
                    登録
                </button>
                </form>
                <div className="text-center mt-4 text-sm">
                    <Link href="/password-reset" className="text-purple-600 hover:text-purple-800 font-medium hover:underline">
                        パスワードをお忘れの方はこちら
                    </Link>
                </div>
                <div className="absolute -top-10 -left-10 w-32 h-32 bg-purple-200 rounded-full opacity-30 blur-3xl animate-pulse-slow"></div>
                <div className="absolute -bottom-10 -right-10 w-40 h-40 bg-pink-200 rounded-full opacity-30 blur-3xl animate-pulse-slow"></div>
            </div>
        </div>
    )
};
