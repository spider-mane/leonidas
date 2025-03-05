import {
  createEffect,
  mergeProps,
  onCleanup,
  onMount,
  ParentProps,
  splitProps,
} from 'solid-js';
import {createSwapy, Swapy} from 'swapy';

/**
 * @typedef {typeof createSwapy} SwapyFunction
 * @typedef {Parameters<SwapyFunction>[1]} SwapyConfig

 * @typedef {Parameters<Swapy["onSwap"]>[0]} SwapCallback
 * @typedef {Parameters<Swapy["onSwapEnd"]>[0]} SwapEndCallback
 * @typedef {Parameters<Swapy["onSwapStart"]>[0]} SwapStartCallback
 *
 * @typedef {{
 *  readonly onCreate: (s: Pick<Swapy, "setData">, ref: HTMLDivElement) => void
 *  readonly onSwap: SwapCallback
 *  readonly onSwapEnd: SwapEndCallback
 *  readonly onSwapStart: SwapStartCallback
 *   }} SwapyEvents
 *
 * @typedef {SwapyConfig &
 *   Partial<SwapyEvents> & {
 *     list: import('solid-js').Signal
 *     readonly class?: string;
 *     readonly style?: JSX.CSSProperties | string;
 *     readonly enabled?: boolean;
 *   }} Props
 */

/**
 * @param {ParentProps<Props>} props
 */
export default function DragContainer(props) {
  /** @type {HTMLDivElement} */
  let ref;

  const merged = mergeProps({enabled: true}, props);
  const [list, listExtracted] = splitProps(merged, ['list']);
  const [containerProps, swapyProps] = splitProps(listExtracted, [
    'class',
    'style',
    'children',
  ]);
  const [events, swapyConfigWithEnabled] = splitProps(swapyProps, [
    'onCreate',
    'onSwap',
    'onSwapEnd',
    'onSwapStart',
  ]);
  const [toggle, swapyConfig] = splitProps(swapyConfigWithEnabled, ['enabled']);

  onMount(() => {
    const swapy = createSwapy(ref, swapyConfig);
    events.onCreate?.(swapy, ref);

    if (events.onSwap) swapy.onSwap(events.onSwap);
    if (events.onSwapStart) swapy.onSwapStart(events.onSwapStart);
    if (events.onSwapEnd) swapy.onSwapEnd(events.onSwapEnd);

    createEffect(() => {
      swapy.enable(toggle.enabled);
    });

    onCleanup(() => {
      swapy.destroy();
    });
  });

  return <div ref={ref} {...containerProps} />;
}
