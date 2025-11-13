import { FaStar } from 'react-icons/fa'

type StarProps = {
    selected: boolean;
};

export const Star = ({ selected }: StarProps) => {
    return (
        <FaStar color={selected ? '#facc15' : '#d1d5db'} />
    );
};
