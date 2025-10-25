'use client';

import { useRouter } from 'next/navigation';

type FormDataType = {
  name: string;
};

export const useSubmit = (reset: (value?: FormDataType) => void) => {
  const router = useRouter();

  const onSubmit = async (data: FormDataType) => {
    const { name } = data
    router.push(`/facilities?name=${name}`);

    // フォームはリセット
    reset()
  };
  
  return { onSubmit };
};
