'use client';
import Link from 'next/link';

type Props = {
  href: string;
  text: string;
  className?: string;
};

export const CustomLink = ({ href, text, className = '' }: Props): React.JSX.Element => {
  return (
    <>
      <Link href={href} className={className}>
        {text}
      </Link>
    </>
  );
};
