# Gallery Generator Manual

### Grid Size
numRowsMobile / numColsMobile → Rows & columns for mobile view.
numRowsDesktop / numColsDesktop → Rows & columns for desktop view.

containerWidth/containerHeight → width and height the container should take
```
const containerWidth = 50; 
const containerHeight = 50; 
```

gapSize → Defines the spacing between images in the grid.
```
 const gapSize = "5% 5%";
```

breakPoint → Defines when the grid should switch between Mobile and Desktop mode.
```
const breakPoint = 1000; 

```


### Image Transformations
offsetXEven/offsetXOdd → Changed the Offset of the images on the X-axis depending if the image is Even or Odd in the Checkerboard grid.
```
 offsetX = (Math.random() - 0.5) * offsetXOdd;
```

offsetYEven/offsetYOdd → Changed the Offset of the images on the Y-axis depending if the image is Even or Odd in the Checkerboard grid.
```
 offsetY = (Math.random() - 0.5) * offsetYOdd;
```


scaleEven/scaleOdd → Changed the Scale of the images depending if the image is Even or Odd in the Checkerboard grid.
```
 scale = Math.random() / scaleParam + scaleOdd;
```


scaleParam → Scales down the maximum amount of randomness.
```
 scale = Math.random() / scaleParam + scaleOdd;
```


imageWidth → Sets the standard image width.
```
img.style.width = `${imageWidth}%`;
```

aspectRatio → Sets the aspect ratio of the box around the image.
```
const aspectRatio = 1/1; // Set aspect ratio
div.style.aspectRatio = `${aspectRatio}`;
```


So in general every image is being moved according to these variables:
```
img.style.width = `${imageWidth}%`;
img.style.transform = "translate(${offsetX}%, ${offsetY}%) scale(${scale})";
```
