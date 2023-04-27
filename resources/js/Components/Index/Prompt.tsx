interface Props {
    promptValue: string;
    setData: (field: string, data: string) => void;
}
export default function Prompt({ promptValue, setData }: Props) {
    return (
        <form>
            <textarea
                placeholder="Enter your prompt to generate p5.js code and then click 'Generate Code'. "
                id="prompt"
                className="w-full"
                value={promptValue}
                onChange={(e) => setData("prompt", e.target.value)}
            ></textarea>
        </form>
    );
}
