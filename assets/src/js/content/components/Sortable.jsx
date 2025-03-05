function otherstuff() {
  sortable = SortableJs.create(sortableContainerRef, {
    ...options,
    animation: 150,
    onStart(event) {
      dragging.item = ourProps.items[parseInt(event.item.dataset.index)];
      options.onStart?.(event);
    },
    onAdd(event) {
      const children = [...event.to?.children];
      const newItems = children.map(
        v =>
          ourProps.items.find(
            item => item[ourProps.idField].toString() === v.dataset.id
          ) || dragging.item
      );
      // from: where it came from
      // to:   added to
      children.splice(event.newIndex, 1);
      event.to?.replaceChildren(...children);

      ourProps.setItems(newItems);
      options.onAdd?.(event);
    },
    onRemove(event) {
      // from: where it removed from
      // to: where it added to
      const children = [...event.from?.children];
      const newItems = children.map(v =>
        ourProps.items.find(
          item => item[ourProps.idField].toString() === v.dataset.id
        )
      );

      children.splice(event.oldIndex, 0, event.item);
      event.from.replaceChildren(...children);
      ourProps.setItems(newItems);
      options.onRemove?.(event);
    },
    onEnd(event) {
      const children = [...sortableContainerRef?.children];
      const newItems = children.map(v =>
        ourProps.items.find(
          item => item[ourProps.idField].toString() === v.dataset.id
        )
      );
      children.sort(
        (a, b) => parseInt(a.dataset.index) - parseInt(b.dataset.index)
      );
      sortableContainerRef?.replaceChildren(...children);
      ourProps.setItems(newItems);
      dragging.item = undefined;
      options.onEnd?.(event);
    },
  });

  onCleanup(() => {
    sortable.destroy();
  });

  createEffect(prev => {
    const clonedProps = {...options};
    if (!prev) {
      //console.debug('props init', clonedProps)
    } else {
      const diff = Object.entries(clonedProps).filter(
        ([key, newVal]) => newVal != prev[key]
      );
      //console.debug('props update', diff, { newProps: clonedProps, prev })
      for (const [key, newVal] of diff) {
        if (['onStart', 'onAdd', 'onRemove', 'onEnd'].includes(key))
          console.warn(
            `Reactive callbacks are not supported yet in solid-sortablejs. Changed:`,
            key
          );
        else sortable.option(key, newVal);
      }
    }
    return clonedProps;
  }, null);
}
