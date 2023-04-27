import { useEffect, useRef, useState } from "react";
import { useForm } from "@inertiajs/react";
import p5 from "p5";
import CodeMirror from "@uiw/react-codemirror";
import { javascript } from "@codemirror/lang-javascript";
import Prompt from "@/Components/Index/Prompt";

interface Props {
    initialPromptValue: string;
    initialCodeValue: string;
}

export default function Index({ initialPromptValue, initialCodeValue }: Props) {
    const { data, setData, post } = useForm({
        prompt: initialPromptValue,
        code: initialCodeValue,
    });

    useEffect(() => {
        setData("code", initialCodeValue);
    }, [initialCodeValue]);

    const submit = (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => {
        if (data.prompt !== "") post("/");
    };

    const evalCode = (code: string) => {
        // This is a bit of a hack but seems to hold up, if anyone knows a better way then please let me know.
        eval(code);
        //@ts-ignore
        document.getElementById("p5-container").innerHTML = "";
        //@ts-ignore
        new p5(window.sketch, "p5-container");
    };

    const ToolBar = () => (
        <div>
            <button
                onClick={(e) => {
                    e.preventDefault();
                    evalCode(data.code);
                }}
                className="btn m-1 no-animation"
            >
                Eval Code
            </button>
            <button onClick={(e) => submit(e)} className="btn m-1 no-animation">
                Generate Code
            </button>
        </div>
    );

    return (
        <div>
            <ToolBar />
            <div className="flex flex-row">
                <div className="w-1/2">
                    <Prompt promptValue={data.prompt} setData={setData} />
                    <CodeMirror
                        width="100%"
                        value={data.code}
                        extensions={[javascript()]}
                        onChange={(value) => setData("code", value)}
                    />
                </div>
                <div className="w-1/2">
                    <div id="p5-container" className="border"></div>
                </div>
            </div>
        </div>
    );
}
